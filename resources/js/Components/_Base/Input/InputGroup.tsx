import {
    InputError,
    InputLabel,
    TextInput,
} from '@/Components/_Base/Input/index'
import { forwardRef, HTMLInputAutoCompleteAttribute, ReactNode } from 'react'
import { twMerge } from 'tailwind-merge'

interface InputGroupProps {
    type?: 'text' | 'email' | 'date' | 'number'
    name: string
    label: string
    placeholder?: string
    value: string | number
    onChange?: (value: string) => void
    onBlur?: (event: React.FocusEvent) => void
    error?: string
    append?: string | ReactNode
    leading?: string
    className?: string
    readOnly?: boolean
    autoComplete?: HTMLInputAutoCompleteAttribute
    containerClassName?: string
    min?: number
    max?: number
}

export default forwardRef(function InputGroup(
    {
        name,
        label,
        value,
        onChange,
        onBlur,
        error,
        placeholder,
        type = 'text',
        append,
        leading,
        className = '',
        readOnly = false,
        autoComplete,
        containerClassName,
        ...props
    }: InputGroupProps,
    ref,
) {
    return (
        <div className={containerClassName}>
            <InputLabel htmlFor={name} value={label} />

            <TextInput
                id={name}
                ref={ref}
                value={value}
                maxLength={255}
                append={append}
                leading={leading}
                autoComplete={autoComplete}
                onChange={(e) => onChange?.(e.target.value)}
                onBlur={(e) => onBlur?.(e)}
                type={type}
                placeholder={placeholder}
                className={twMerge('block w-full', className)}
                readOnly={readOnly}
                {...props}
            />

            <InputError message={error} className="mt-2" />
        </div>
    )
})
