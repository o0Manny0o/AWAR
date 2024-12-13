import { HTMLAttributes } from 'react'
import useTranslate from '@/shared/hooks/useTranslate'

export default function InputError({
    message,
    className = '',
    ...props
}: HTMLAttributes<HTMLParagraphElement> & { message?: string }) {
    const __ = useTranslate()
    return message ? (
        <p
            {...props}
            className={'text-sm text-red-600 dark:text-red-400 ' + className}
        >
            {__(message as TranslationKey)}
        </p>
    ) : null
}
