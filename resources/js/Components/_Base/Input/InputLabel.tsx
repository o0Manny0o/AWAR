import { LabelHTMLAttributes } from 'react'
import { twMerge } from 'tailwind-merge'

export default function InputLabel({
    value,
    className = '',
    children,
    ...props
}: LabelHTMLAttributes<HTMLLabelElement> & { value?: string }) {
    return (
        <label
            {...props}
            className={twMerge(
                'text-basic block text-sm font-medium',
                className,
            )}
        >
            {value ? value : children}
        </label>
    )
}
