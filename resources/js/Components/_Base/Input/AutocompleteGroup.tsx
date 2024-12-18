import { InputError, InputLabel } from '@/Components/_Base/Input/index'
import { HTMLInputAutoCompleteAttribute, ReactNode } from 'react'
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
    withEmptyOption?: string
    optionsClassName?: string
    autoComplete?: HTMLInputAutoCompleteAttribute
}

export default function AutocompleteGroup<T extends Option>({
    name,
    label,
    onChange,
    error,
    className = '',
    readOnly = false,
    ...props
}: InputGroupProps<T>) {
    return (
        <div>
            <InputLabel htmlFor={name} value={label} />

            <AutocompleteInput
                {...props}
                id={name}
                name={name}
                maxLength={255}
                onChange={(value) => onChange?.(value)}
                className={twMerge('block w-full', className)}
                readOnly={readOnly}
            />

            <InputError message={error} className="mt-2" />
        </div>
    )
}
