import { ForwardedRef, forwardRef, InputHTMLAttributes } from 'react'
import { twMerge } from 'tailwind-merge'

export default forwardRef(function TextArea(
    {
        type = 'text',
        className = '',
        rows = 4,
        ...props
    }: InputHTMLAttributes<HTMLTextAreaElement> & {
        rows?: number
    },
    ref: ForwardedRef<HTMLTextAreaElement>,
) {
    return (
        <textarea
            {...props}
            ref={ref}
            rows={rows}
            className={twMerge(
                `bg-ceiling text-basic block w-full rounded-md border-0 px-3 py-1.5 outline
                outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400
                read-only:outline-0 focus:outline focus:outline-2 focus:-outline-offset-2
                focus:outline-primary-500 read-only:focus:outline-0 sm:text-sm sm:leading-6
                dark:focus:outline-primary-600`,
                className,
            )}
        />
    )
})
