import { CheckIcon } from '@heroicons/react/24/solid'
import { ComboboxOption } from '@headlessui/react'
import { ReactNode } from 'react'

interface AutocompleteInputOptionProps {
    option: any
    body: (value: any) => ReactNode
}

export function AutocompleteInputOption({
    option,
    body,
}: AutocompleteInputOptionProps) {
    return (
        <ComboboxOption
            value={option}
            className="group relative text-basic block w-full pl-4 pr-9 py-2 text-left text-sm
                data-[focus]:bg-primary-600 data-[focus]:outline-none data-[focus]:text-white
                dark:data-[focus]:bg-primary-400/50"
        >
            <div className="flex">{body(option)}</div>

            <span
                className="absolute inset-y-0 right-0 hidden items-center pr-4 text-primary-600
                    dark:text-primary-400 group-data-[selected]:flex group-data-[focus]:text-white"
            >
                <CheckIcon className="size-5" aria-hidden="true" />
            </span>
        </ComboboxOption>
    )
}
