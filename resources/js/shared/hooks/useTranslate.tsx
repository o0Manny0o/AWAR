import { usePage } from '@inertiajs/react'
import { get } from 'lodash-es'
import en from '../../../../lang/en.json'
import de from '../../../../lang/de.json'
import { useMemo } from 'react'

export function toTranslationKey(key: string): TranslationKey {
    return key.replace(/-/g, '_') as TranslationKey
}

export default function useTranslate() {
    const { locale } = usePage().props

    const translationMap = useMemo(
        () =>
            new Map([
                ['en', en as Translations],
                ['de', de as Translations],
            ]),
        [],
    )

    return (key: TranslationKey, replace: TranslationReplace = {}) => {
        const translations = translationMap.get(locale)
        let translation = get(translations, key) as string | undefined
        if (!translation) {
            if (locale === 'en') return key
            translation = get(translationMap.get('en'), key, key) as string
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
