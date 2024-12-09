export function getAbbreviation(text: string) {
    if (!text) {
        return ''
    }
    if (!text.match(/\s/g)) {
        return text.toUpperCase()
    }
    return text
        .match(/[\p{Alpha}\p{Nd}]+/gu)
        ?.reduce(
            (previous, next) =>
                previous +
                (+next === 0 || parseInt(next)
                    ? parseInt(next)
                    : next[0] || ''),
            '',
        )
        .toUpperCase()
}

export function getArrayErrors(
    errors: Record<string, string>,
    propertyKey: string,
) {
    return Object.fromEntries(
        Object.entries(errors).filter(([key]) => key.startsWith(propertyKey)),
    )
}

export function mapErrorsToIds(
    entries: { id: string }[],
    errors?: Record<string, string>,
) {
    return Object.fromEntries(
        Object.entries(errors ?? {}).map(([key, value]) => {
            const idx: string | undefined = key.split('.')[1]
            if (!idx || isNaN(parseInt(idx))) {
                return [key, value]
            }
            const entry = entries[parseInt(idx)]
            return [entry.id, value]
        }),
    )
}
