import { InputError, InputLabel } from '@/Components/_Base/Input/index'
import { ReactNode } from 'react'
import { twMerge } from 'tailwind-merge'
import AutocompleteInput, {
    Option,
} from '@/Components/_Base/Input/AutocompleteInput'

interface InputGroupProps<T extends Option> {
    name: string
    label: string
    placeholder?: string
    value?: string | null
    options: T[]
    onChange?: (value: T | null) => void
    error?: string
    className?: string
    readOnly?: boolean
    description?: (value: T) => ReactNode
    canCreate?: boolean
}

export default function AutocompleteGroup<T extends Option>({
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
    canCreate,
}: InputGroupProps<T>) {
    return (
        <div>
            <InputLabel htmlFor={name} value={label} />

            <AutocompleteInput
                options={options}
                id={name}
                value={value}
                maxLength={255}
                onChange={(value) => onChange?.(value)}
                placeholder={placeholder}
                className={twMerge('block w-full', className)}
                readOnly={readOnly}
                description={description}
                canCreate={canCreate}
            />

            <InputError message={error} className="mt-2" />
        </div>
    )
}
