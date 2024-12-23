import { useSortable } from '@dnd-kit/sortable'
import { CSS } from '@dnd-kit/utilities'
import { XMarkIcon } from '@heroicons/react/24/outline'
import { ReactNode, useMemo } from 'react'
import { twMerge } from 'tailwind-merge'
import { InputError } from '@/Components/_Base/Input'

interface ImagePreviewProps {
    id: string
    file?: File | string
    onButtonClick?: (id: string) => void
    first?: boolean
    error?: string
    buttonIcon?: ReactNode
}

export function ImagePreview({
    onButtonClick,
    id,
    file,
    error,
    buttonIcon = <XMarkIcon />,
}: ImagePreviewProps) {
    const { attributes, listeners, setNodeRef, transition, transform } =
        useSortable({
            id: id,
        })

    const style = {
        transform: CSS.Transform.toString(transform),
        transition,
    }

    const url = useMemo(() => {
        return file
            ? typeof file === 'string'
                ? file
                : URL.createObjectURL(file)
            : null
    }, [file])

    return (
        <div className="flex flex-col w-min">
            <div ref={setNodeRef} style={style} className="relative">
                {onButtonClick && (
                    <button
                        type="button"
                        className="absolute end-2 top-2 size-8 p-2 rounded-full bg-gray-100 hover:bg-gray-300
                            text-gray-700"
                        onClick={(e) => {
                            e.stopPropagation()
                            onButtonClick(id)
                        }}
                    >
                        {buttonIcon}
                    </button>
                )}
                <div
                    className={twMerge(
                        `size-44 rounded-md bg-gray-600 border-2 border-transparent flex items-center
                        justify-center overflow-hidden`,
                        error && 'border-red-500',
                    )}
                >
                    {url ? (
                        <img
                            className="object-cover w-full h-full"
                            src={url}
                            {...attributes}
                            {...listeners}
                            alt={'Selected image'}
                        />
                    ) : (
                        <span>No Image selected</span>
                    )}
                </div>
            </div>
            {error && <InputError className="w-44" message={error} />}
        </div>
    )
}
