import { useSortable } from '@dnd-kit/sortable'
import { CSS } from '@dnd-kit/utilities'
import { XMarkIcon } from '@heroicons/react/24/outline'
import { useMemo } from 'react'
import { twMerge } from 'tailwind-merge'
import { InputError } from '@/Components/_Base/Input'

interface ImagePreviewProps {
    image: { id: string; file: File | string }
    onDeleteClick: (id: string) => void
    first?: boolean
    error?: string
}

export function ImagePreview({
    onDeleteClick,
    image: { id, file },
    error,
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
        return typeof file === 'string' ? file : URL.createObjectURL(file)
    }, [file])

    return (
        <div className="flex flex-col">
            <div ref={setNodeRef} style={style} className="relative">
                <button
                    type="button"
                    className="absolute end-2 top-2 size-8 p-2 rounded-full bg-gray-100 hover:bg-gray-300
                        text-gray-700"
                    onClick={(e) => {
                        e.stopPropagation()
                        onDeleteClick(id)
                    }}
                >
                    <XMarkIcon />
                </button>
                <img
                    className={twMerge(
                        'size-44 object-cover rounded-md border-2 border-transparent',
                        error && 'border-red-500',
                    )}
                    src={url}
                    {...attributes}
                    {...listeners}
                    alt={'Selected image'}
                />
            </div>
            {error && <InputError className="w-44" message={error} />}
        </div>
    )
}
