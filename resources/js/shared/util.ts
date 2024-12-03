export function getAbbreviation(text: string) {
    if (!text) {
        return ''
    }
    if (!text.match(/\s/g)) {
        return text
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
