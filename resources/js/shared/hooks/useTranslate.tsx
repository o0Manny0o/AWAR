import { usePage } from '@inertiajs/react'
import { get } from 'lodash-es'

export default function useTranslate() {
    const { translations } = usePage().props

    return (key: TranslationKey, replace: Record<string, string> = {}) => {
        let translation = get(translations, key, key) as string
        Object.keys(replace).forEach(function (k) {
            translation = translation.replace(':' + k, replace[k])
        })
        return translation
    }
}
