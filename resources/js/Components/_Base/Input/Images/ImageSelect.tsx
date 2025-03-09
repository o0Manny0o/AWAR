import { ReactNode } from 'react'
import { twJoin } from 'tailwind-merge'
import { InputLabel } from '@/Components/_Base/Input'
import Media = App.Models.Media

interface ImageSelectProps {
    images: Media[]
    title: (m: Media) => ReactNode
    subtitle?: (m: Media) => ReactNode
    selected: number[]
    onSelect: (m: Media) => void
    onRemove: (m: Media) => void
    label?: string
}

export function ImageSelect({
    images,
    title,
    subtitle,
    selected,
    onSelect,
    onRemove,
    label,
}: ImageSelectProps) {
    const updateSelected = (media: Media) => {
        if (!selected.includes(media.id)) {
            onSelect(media)
        } else {
            onRemove(media)
        }
    }

    return (
        <>
            {label && <InputLabel>{label}</InputLabel>}
            <ul
                role="list"
                className="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4
                    xl:gap-x-8"
            >
                {images.map((image) => (
                    <li key={image.file_url} className="relative">
                        <div
                            className={twJoin(
                                'group overflow-hidden rounded-lg focus-within:ring-4 ring-primary-500 ',
                                selected.includes(image.id)
                                    ? 'selected ring-2'
                                    : '',
                            )}
                        >
                            <img
                                alt=""
                                src={image.file_url}
                                className="pointer-events-none aspect-[10/7] transition-opacity object-cover opacity-75
                                    group-hover:opacity-90 group-[.selected]:opacity-100
                                    group-focus-within:opacity-100"
                            />
                            <label className="absolute inset-0 focus:outline-none">
                                <input
                                    type="checkbox"
                                    value={image.id}
                                    checked={selected.includes(image.id)}
                                    className="hidden"
                                    onChange={() => updateSelected(image)}
                                />
                                <span className="sr-only">Image selected</span>
                            </label>
                        </div>
                        <p className="pointer-events-none mt-2 block truncate text-sm font-medium">
                            {title(image)}
                        </p>
                        {subtitle && (
                            <p className="pointer-events-none block text-sm font-medium text-gray-500">
                                {subtitle(image)}
                            </p>
                        )}
                    </li>
                ))}
            </ul>
        </>
    )
}
