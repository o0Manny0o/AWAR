import {
    forwardRef,
    InputHTMLAttributes,
    ReactNode,
    useEffect,
    useImperativeHandle,
    useRef,
} from 'react'
import { twMerge } from 'tailwind-merge'

export default forwardRef(function TextInput(
    {
        type = 'text',
        className = '',
        isFocused = false,
        append,
        leading,
        ...props
    }: InputHTMLAttributes<HTMLInputElement> & {
        isFocused?: boolean
        append?: string | ReactNode
        leading?: string
    },
    ref,
) {
    const localRef = useRef<HTMLInputElement>(null)

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }))

    useEffect(() => {
        if (isFocused) {
            localRef.current?.focus()
        }
    }, [isFocused])

    return (
        <div className="relative mt-2 rounded-md shadow-sm">
            {leading && (
                <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span className="text-gray-500 sm:text-sm dark:text-gray-400">
                        {leading}
                    </span>
                </div>
            )}
            <input
                {...props}
                type={type}
                ref={localRef}
                className={twMerge(
                    `bg-ceiling text-basic block w-full rounded-md border-0 py-1.5 ring-1 ring-inset
                    ring-gray-300 placeholder:text-gray-400 read-only:ring-0 focus:ring-2
                    focus:ring-inset focus:ring-primary-500 read-only:focus:ring-0 sm:text-sm
                    sm:leading-6 dark:focus:ring-primary-600`,
                    append ? 'pr-12' : '',
                    leading ? 'pl-7' : '',
                    className,
                )}
            />
            {append && (
                <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <span
                        id={`${props.id}-appendix`}
                        className="text-gray-500 sm:text-sm dark:text-gray-400"
                    >
                        {append}
                    </span>
                </div>
            )}
        </div>
    )
})
