import { forwardRef, useEffect, useImperativeHandle, useRef } from 'react'
import {
    Description,
    Field,
    Label,
    Switch,
    SwitchProps,
} from '@headlessui/react'
import { twMerge } from 'tailwind-merge'
import { InputError } from '@/Components/_Base/Input/index'

export default forwardRef(function SwitchInput(
    {
        className = '',
        isFocused = false,
        description,
        label,
        error,
        readOnly,
        ...props
    }: SwitchProps & {
        className?: string
        isFocused?: boolean
        description?: string
        label?: string
        error?: string
        readOnly?: boolean
    },
    ref,
) {
    const localRef = useRef<HTMLButtonElement>(null)

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }))

    useEffect(() => {
        if (isFocused) {
            localRef.current?.focus()
        }
    }, [isFocused])

    return (
        <Field
            disabled={readOnly}
            className={twMerge(className, 'flex items-center justify-between')}
        >
            <span className="flex grow flex-col">
                <Label as="span" passive className="text-sm/6 font-medium">
                    {label}
                </Label>
                <Description as="span" className="text-sm text-gray-500">
                    {description}
                </Description>
            </span>
            <Switch
                {...props}
                ref={localRef}
                className="bg-ceiling group relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent ring-1 ring-gray-300 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 data-[disabled]:cursor-default data-[checked]:bg-primary-600"
            >
                <span
                    aria-hidden="true"
                    className="pointer-events-none inline-block size-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out group-data-[checked]:translate-x-5"
                />
            </Switch>

            <InputError message={error} className="mt-2" />
        </Field>
    )
})
