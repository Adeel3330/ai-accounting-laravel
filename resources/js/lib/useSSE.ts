export interface SSEEvent {
  id?: string;
  type?: string;
  [key: string]: any;
}

/**
 * Parse an SSE ReadableStream and yield JSON events.
 */
export async function* parseSSEStream(
  reader: ReadableStreamDefaultReader<Uint8Array>
): AsyncGenerator<SSEEvent> {
  const decoder = new TextDecoder();
  let buffer = '';

  while (true) {
    const { done, value } = await reader.read();

    if (done) {
      buffer += decoder.decode();
      break;
    }

    buffer += decoder.decode(value, { stream: true });

    const events = buffer.split('\n\n');

    // Keep incomplete SSE event for the next chunk
    buffer = events.pop() || '';

    for (const event of events) {
      const parsed = parseSSEEvent(event);

      if (parsed) {
        yield parsed;
      }
    }
  }

  // Handle remaining event
  if (buffer.trim()) {
    const parsed = parseSSEEvent(buffer);

    if (parsed) {
      yield parsed;
    }
  }
}

/**
 * Parse a single SSE event.
 */
export function parseSSEEvent(event: string): SSEEvent | null {
  const dataLines = event
    .split('\n')
    .filter(line => line.startsWith('data:'))
    .map(line => line.slice(5).trim());

  if (!dataLines.length) {
    return null;
  }

  const raw = dataLines.join('\n');

  if (!raw || raw === '[DONE]') {
    return null;
  }

  try {
    return JSON.parse(raw) as SSEEvent;
  } catch (error) {
    console.error('Invalid SSE JSON:', raw, error);
    return null;
  }
}