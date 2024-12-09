import { InputError, InputLabel } from '@/Components/_Base/Input/index'
import { forwardRef, ReactNode } from 'react'
import { twMerge } from 'tailwind-merge'
import CreatableInput, { Option } from '@/Components/_Base/Input/CreatableInput'

interface InputGroupProps<T extends Option> {
    name: string
    label: string
    placeholder?: string
    value: T
    options: T[]
    onChange?: (value: T | null) => void
    error?: string
    className?: string
    readOnly?: boolean
    description?: (value: T) => ReactNode
}

export default forwardRef(function CreatableGroup<T extends Option>(
    {
        name,
        label,
        value,
        onChange,
        error,
        placeholder,
        className = '',
        readOnly = false,
        description,
        options,
    }: InputGroupProps<T>,
    ref,
) {
    return (
        <div>
            <InputLabel htmlFor={name} value={label} />

            <CreatableInput
                options={options}
                id={name}
                ref={ref}
                value={value}
                maxLength={255}
                onChange={(value) => onChange?.(value)}
                placeholder={placeholder}
                className={twMerge('block w-full', className)}
                readOnly={readOnly}
                description={description}
            />

            <InputError message={error} className="mt-2" />
        </div>
    )
})
