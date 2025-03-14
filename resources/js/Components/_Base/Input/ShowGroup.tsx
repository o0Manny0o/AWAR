import InputLabel from '@/Components/_Base/Input/InputLabel'
import { twMerge } from 'tailwind-merge'

interface ShowGroupProps {
    name: string
    label: string
    value?: string
    append?: string
    leading?: string
    className?: string
}

export default function ShowGroup({
    name,
    label,
    value,
    append,
    leading,
    className = '',
}: ShowGroupProps) {
    return (
        <div className="space-y-2">
            <InputLabel
                htmlFor={name}
                value={label}
                className="text-gray-600 dark:text-gray-300"
            />

            <p
                id={name}
                className={twMerge('block w-full font-semibold', className)}
            >
                {value ? (
                    <>
                        {leading}
                        {value || ' - '}
                        {append}
                    </>
                ) : (
                    ' - '
                )}
            </p>
        </div>
    )
}
