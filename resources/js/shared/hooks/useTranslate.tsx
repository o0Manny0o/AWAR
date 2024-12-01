import { usePage } from '@inertiajs/react'
import { get } from 'lodash-es'

export function toTranslationKey(key: string): TranslationKey {
    return key.replace(/-/g, '_') as TranslationKey
}

export default function useTranslate() {
    const { translations, fallback } = usePage().props

    return (key: TranslationKey, replace: TranslationReplace = {}) => {
        let translation = get(translations, key) as string | undefined
        if (!translation) {
            if (!fallback) return key
            translation = get(fallback, key, key) as string
        }
        Object.keys(replace).forEach(function (k) {
            translation = translation!.replace(
                ':' + k,
                get(translations, replace[k], replace[k]),
            )
        })
        return !translation ? key : translation
    }
}
