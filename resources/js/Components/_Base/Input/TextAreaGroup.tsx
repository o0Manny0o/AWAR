import { InputError, InputLabel } from '@/Components/_Base/Input/index'
import { FocusEvent, ForwardedRef, forwardRef } from 'react'
import { twMerge } from 'tailwind-merge'
import TextArea from '@/Components/_Base/Input/TextArea'

interface InputGroupProps {
    name: string
    label: string
    placeholder?: string
    value: string | number
    onChange?: (value: string) => void
    onBlur?: (event: FocusEvent) => void
    error?: string
    className?: string
    readOnly?: boolean
    containerClassName?: string
    maxLength?: number
}

export default forwardRef(function TextAreaGroup(
    {
        name,
        label,
        value,
        onChange,
        onBlur,
        error,
        placeholder,
        className = '',
        readOnly = false,
        containerClassName,
        maxLength = 255,
        ...props
    }: InputGroupProps,
    ref: ForwardedRef<HTMLTextAreaElement>,
) {
    return (
        <div className={containerClassName}>
            <InputLabel htmlFor={name} value={label} />

            <TextArea
                id={name}
                ref={ref}
                value={value}
                maxLength={maxLength}
                onChange={(e) => onChange?.(e.target.value as string)}
                onBlur={(e) => onBlur?.(e)}
                placeholder={placeholder}
                className={twMerge('block w-full mt-2', className)}
                readOnly={readOnly}
                {...props}
            />

            <InputError message={error} className="mt-2" />
        </div>
    )
})
