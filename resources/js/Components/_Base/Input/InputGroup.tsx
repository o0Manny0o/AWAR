import {
    InputError,
    InputLabel,
    TextInput,
} from '@/Components/_Base/Input/index'
import {
    forwardRef,
    HTMLInputAutoCompleteAttribute,
    useImperativeHandle,
    useRef,
} from 'react'
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
    append?: string
    leading?: string
    className?: string
    readOnly?: boolean
    autoComplete?: HTMLInputAutoCompleteAttribute
    containerClassName?: string
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
    }: InputGroupProps,
    ref,
) {
    const localRef = useRef<HTMLInputElement>(null)

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }))

    return (
        <div className={containerClassName}>
            <InputLabel htmlFor={name} value={label} />

            <TextInput
                id={name}
                ref={localRef}
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
            />

            <InputError message={error} className="mt-2" />
        </div>
    )
})
