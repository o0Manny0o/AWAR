import Dropzone from 'react-dropzone'
import { useEffect, useState } from 'react'
import { twMerge } from 'tailwind-merge'
import { ImagePreview } from '@/Components/_Base/Input/Images/ImagePreview'
import InputError from '@/Components/_Base/Input/InputError'

interface ImageInputProps {
    image: File | string
    onChange: (files: File | string) => void
    errors?: Record<string, string>
}

export function ImageInput({ onChange, image, errors }: ImageInputProps) {
    const [selectedImage, setSelectedImage] = useState<File | string>(image)

    useEffect(() => {
        onChange(selectedImage)
    }, [selectedImage])

    return (
        <div>
            <Dropzone
                accept={{ 'image/*': ['.jpeg', '.png', '.jpg', '.webp'] }}
                multiple={false}
                onDrop={(acceptedFiles: File[]) =>
                    setSelectedImage(acceptedFiles?.[0])
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

            <div className="flex my-4 gap-4 flex-wrap after:content-[''] after:flex-auto">
                <ImagePreview id={'image'} file={selectedImage} />
            </div>
            {errors && errors['images'] && (
                <InputError message={errors['images']} className="mt-2" />
            )}
        </div>
    )
}
