import {
    InputError,
    InputLabel,
    TextInput,
} from '@/Components/_Base/Input/index'
import { forwardRef, useImperativeHandle, useRef } from 'react'
import { twMerge } from 'tailwind-merge'

interface InputGroupProps {
    type?: 'text'
    name: string
    label: string
    placeholder?: string
    value: string
    onChange: (value: string) => void
    error?: string
    append?: string
    leading?: string
    className?: string
    readOnly?: boolean
}

export default forwardRef(function InputGroup(
    {
        name,
        label,
        value,
        onChange,
        error,
        placeholder,
        type = 'text',
        append,
        leading,
        className = '',
        readOnly = false,
    }: InputGroupProps,
    ref,
) {
    const localRef = useRef<HTMLInputElement>(null)

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }))

    const renderField = () => {
        switch (type) {
            case 'text':
                return (
                    <TextInput
                        id={name}
                        ref={localRef}
                        value={value}
                        maxLength={255}
                        append={append}
                        leading={leading}
                        onChange={(e) => onChange(e.target.value)}
                        type="text"
                        placeholder={placeholder}
                        className={twMerge('block w-full', className)}
                        readOnly={readOnly}
                    />
                )
        }
    }

    return (
        <div>
            <InputLabel htmlFor={name} value={label} />

            {renderField()}

            <InputError message={error} className="mt-2" />
        </div>
    )
})
