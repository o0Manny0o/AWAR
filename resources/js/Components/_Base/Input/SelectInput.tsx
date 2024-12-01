import { forwardRef, OptionHTMLAttributes, SelectHTMLAttributes } from 'react'
import { ChevronDownIcon } from '@heroicons/react/24/solid'
import { twMerge } from 'tailwind-merge'

type SelectOption = {
    value: string
    label: string
    attributes?: OptionHTMLAttributes<HTMLOptionElement>
}

export type SelectInputProps = SelectHTMLAttributes<HTMLSelectElement> & {
    options: SelectOption[]
}

export default forwardRef<HTMLSelectElement, SelectInputProps>(
    function SelectInput({ options, ...props }: SelectInputProps, ref) {
        return (
            <div className="mt-2 grid grid-cols-1">
                <select
                    ref={ref}
                    {...props}
                    className={twMerge(
                        `text-basic bg-ceiling col-start-1 row-start-1 w-full appearance-none rounded-md
                        bg-none py-1.5 pl-3 pr-8 text-base outline outline-1 -outline-offset-1
                        outline-gray-300 focus:outline-2 focus:-outline-offset-2
                        focus:outline-primary-600 sm:text-sm/6`,
                        props.className,
                    )}
                >
                    {options.map((option) => (
                        <option
                            key={option.value}
                            {...option.attributes}
                            value={option.value}
                        >
                            {option.label}
                        </option>
                    ))}
                </select>
                <ChevronDownIcon
                    aria-hidden="true"
                    className="text-basic pointer-events-none col-start-1 row-start-1 mr-2 size-6 self-center
                        justify-self-end sm:size-4"
                />
            </div>
        )
    },
)
