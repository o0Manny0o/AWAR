import { InputError, InputLabel } from '@/Components/_Base/Input/index'
import {
    ForwardedRef,
    forwardRef,
    HTMLInputAutoCompleteAttribute,
    ReactNode,
} from 'react'
import { twMerge } from 'tailwind-merge'
import AutocompleteInput, {
    Option,
} from '@/Components/_Base/Input/AutocompleteInput'

interface InputGroupProps {
    name: string
    label: string
    placeholder?: string
    value?: string | null
    options: Option[]
    onChange?: (value: Option | null) => void
    error?: string
    className?: string
    readOnly?: boolean
    description?: (value: Option) => ReactNode
    canCreate?: boolean
    withEmptyOption?: string
    optionsClassName?: string
    autoComplete?: HTMLInputAutoCompleteAttribute
    ref?: any
}

export default forwardRef(function AutocompleteGroup(
    {
        name,
        label,
        onChange,
        error,
        className = '',
        readOnly = false,
        ...props
    }: InputGroupProps,
    ref: ForwardedRef<HTMLInputElement>,
) {
    return (
        <div>
            <InputLabel htmlFor={name} value={label} />

            <AutocompleteInput
                {...props}
                id={name}
                name={name}
                ref={ref}
                maxLength={255}
                onChange={(value) => onChange?.(value)}
                className={twMerge('block w-full', className)}
                readOnly={readOnly}
            />

            <InputError message={error} className="mt-2" />
        </div>
    )
})
