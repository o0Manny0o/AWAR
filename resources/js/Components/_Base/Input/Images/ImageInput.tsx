import Dropzone from 'react-dropzone'
import { useEffect, useState } from 'react'
import { twMerge } from 'tailwind-merge'
import {
    arrayMove,
    rectSortingStrategy,
    SortableContext,
    sortableKeyboardCoordinates,
} from '@dnd-kit/sortable'
import {
    closestCenter,
    DndContext,
    KeyboardSensor,
    PointerSensor,
    useSensor,
    useSensors,
} from '@dnd-kit/core'
import { ImagePreview } from '@/Components/_Base/Input/Images/ImagePreview'
import Media = App.Models.Media
import { InputError } from '@/Components/_Base/Input'

interface ImageInputProps {
    images: File[] | Media[]
    onChange: (files: (File | string)[]) => void
    errors?: Record<string, string>
}

function isMedia(item: Media | File): item is Media {
    return !!(item as Media).file_url
}

export function ImageInput({ onChange, images, errors }: ImageInputProps) {
    const [selectedImages, setSelectedImages] = useState<
        { id: string; file: File | string }[]
    >(
        images.map((f) =>
            isMedia(f)
                ? {
                      id: f.id.toString(),
                      file: f.file_url,
                  }
                : { id: Math.random().toString(16).slice(2), file: f },
        ),
    )

    useEffect(() => {
        onChange(
            selectedImages.map((f) =>
                typeof f.file === 'string' ? f.id : (f.file as File),
            ),
        )
    }, [selectedImages])

    const sensors = useSensors(
        useSensor(PointerSensor),
        useSensor(KeyboardSensor, {
            coordinateGetter: sortableKeyboardCoordinates,
        }),
    )

    function handleDragEnd(event: any) {
        const { active, over } = event

        if (active.id !== over.id) {
            setSelectedImages((items) => {
                const oldIndex = items.findIndex((f) => f.id === active.id)
                const newIndex = items.findIndex((f) => f.id === over.id)

                return arrayMove(items, oldIndex, newIndex)
            })
        }
    }

    return (
        <div>
            <Dropzone
                accept={{ 'image/*': ['.jpeg', '.png', '.jpg', '.webp'] }}
                onDrop={(acceptedFiles: File[]) =>
                    setSelectedImages([
                        ...selectedImages,
                        ...acceptedFiles.map((file) => ({
                            id: Math.random().toString(16).slice(2),
                            file,
                        })),
                    ])
                }
            >
                {({
                    getRootProps,
                    getInputProps,
                    isDragActive,
                    isDragReject,
                }) => (
                    <section>
                        <div
                            {...getRootProps()}
                            className={twMerge(
                                `flex flex-col items-center p-8 border-dashed border-2 border-gray-300
                                cursor-pointer hover:bg-primary-600/20`,
                                isDragActive && 'bg-primary-600/20',
                            )}
                        >
                            <input {...getInputProps()} />
                            {isDragActive ? (
                                <p>Drop the files here ...</p>
                            ) : isDragReject ? (
                                <p className="text-red-500">
                                    Only images are allowed
                                </p>
                            ) : (
                                <p>
                                    Drag 'n' drop some files here, or click to
                                    select files
                                </p>
                            )}
                        </div>
                    </section>
                )}
            </Dropzone>

            <DndContext
                sensors={sensors}
                collisionDetection={closestCenter}
                onDragEnd={handleDragEnd}
            >
                <SortableContext
                    items={selectedImages}
                    strategy={rectSortingStrategy}
                >
                    <div className="flex my-4 gap-4 flex-wrap after:content-[''] after:flex-auto">
                        {selectedImages.map((image, idx) => (
                            <ImagePreview
                                key={image.id}
                                image={image}
                                error={
                                    Object.entries(errors ?? {}).find(([key]) =>
                                        key.endsWith(String(idx)),
                                    )?.[1]
                                }
                                onDeleteClick={(e) =>
                                    setSelectedImages((images) =>
                                        images.filter((f) => f.id !== e),
                                    )
                                }
                            />
                        ))}
                    </div>
                </SortableContext>
            </DndContext>
            {errors && errors['images'] && (
                <InputError message={errors['images']} className="mt-2" />
            )}
        </div>
    )
}
