import { useSortable } from '@dnd-kit/sortable'
import { CSS } from '@dnd-kit/utilities'
import { XMarkIcon } from '@heroicons/react/24/outline'
import { useMemo } from 'react'
import { twJoin } from 'tailwind-merge'
import { first } from 'lodash-es'

interface ImagePreviewProps {
    image: { id: string; file: File | string }
    onDeleteClick: (id: string) => void
    first?: boolean
}

export function ImagePreview({
    onDeleteClick,
    first,
    image: { id, file },
}: ImagePreviewProps) {
    const {
        attributes,
        listeners,
        setNodeRef,
        transition,
        transform,
        isDragging,
    } = useSortable({
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
                className={twJoin(
                    'size-44 object-cover rounded-md border-2 border-transparent',
                    !isDragging && first && 'border-primary-500',
                )}
                src={url}
                {...attributes}
                {...listeners}
                alt={'Selected image'}
            />
            {!isDragging && first && (
                <span
                    className="absolute inset-x-0 bottom-0 text-center font-bold text-white bg-primary-500
                        rounded-b-md text-xl"
                >
                    Gallery Image
                </span>
            )}
        </div>
    )
}
