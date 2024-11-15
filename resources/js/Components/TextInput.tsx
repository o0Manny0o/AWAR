import {
    forwardRef,
    InputHTMLAttributes,
    useEffect,
    useImperativeHandle,
    useRef,
} from 'react'

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
        append?: string
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
                    <span className="text-gray-500 sm:text-sm">{leading}</span>
                </div>
            )}
            <input
                {...props}
                type={type}
                ref={localRef}
                className={`block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-300 dark:ring-gray-900 dark:focus:ring-indigo-600 ${append ? 'pr-12' : ''} ${leading ? 'pl-7' : ''} ${className}`}
            />
            {append && (
                <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <span
                        id="price-currency"
                        className="text-gray-500 sm:text-sm"
                    >
                        {append}
                    </span>
                </div>
            )}
        </div>
    )
})
