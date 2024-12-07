import { Card } from '@/Components/Layout/Card'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import { FormEventHandler, useContext } from 'react'
import useTranslate from '@/shared/hooks/useTranslate'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import { CatFormData } from '@/Pages/Tenant/Animals/Lib/Animals.types'
import { AxiosProgressEvent } from 'axios'
import { InputError } from '@/Components/_Base/Input'
import { XMarkIcon } from '@heroicons/react/24/outline'

interface CatFormProps {
    formId: string
    data: CatFormData
    setData: (key: string, value: any) => void
    errors: Errors<CatFormData>
    submitHandler: FormEventHandler
    progress: AxiosProgressEvent | null
}

export function CatForm({
    data,
    setData,
    formId,
    errors,
    submitHandler,
    progress,
}: CatFormProps) {
    const __ = useTranslate()
    const {
        refs: { name, breed, date_of_birth, bio, abstract },
    } = useContext(CatFormWrapper.Context)
    return (
        <form id={formId} onSubmit={submitHandler}>
            <div className="space-y-6 py-6">
                <Card>
                    <InputGroup
                        name="name"
                        placeholder={__('animals.cats.form.name.placeholder')}
                        value={data.name}
                        ref={name}
                        label={__('animals.cats.form.name.label')}
                        error={errors.name}
                        onChange={(value) => setData('name', value)}
                    />
                    <InputGroup
                        name="breed"
                        placeholder={__('animals.cats.form.breed.placeholder')}
                        value={data.breed}
                        ref={breed}
                        label={__('animals.cats.form.breed.label')}
                        error={errors.breed}
                        onChange={(value) => setData('breed', value)}
                    />
                    <InputGroup
                        name="date_of_birth"
                        placeholder={__(
                            'animals.cats.form.date_of_birth.placeholder',
                        )}
                        value={data.date_of_birth}
                        ref={date_of_birth}
                        label={__('animals.cats.form.date_of_birth.label')}
                        error={errors.date_of_birth}
                        type={'date'}
                        onChange={(value) => setData('date_of_birth', value)}
                    />
                </Card>

                <Card>
                    <InputGroup
                        name="bio"
                        placeholder={__('animals.dogs.form.bio.placeholder')}
                        value={data.bio}
                        ref={bio}
                        label={__('animals.dogs.form.bio.label')}
                        error={errors.bio}
                        onChange={(value) => setData('bio', value)}
                    />
                    <InputGroup
                        name="abstract"
                        placeholder={__(
                            'animals.dogs.form.abstract.placeholder',
                        )}
                        value={data.abstract}
                        ref={abstract}
                        label={__('animals.dogs.form.abstract.label')}
                        error={errors.abstract}
                        onChange={(value) => setData('abstract', value)}
                    />
                </Card>

                <Card header="Images">
                    <input
                        name="images[]"
                        type="file"
                        multiple
                        accept="image/*"
                        onChange={(e) =>
                            setData('images', [
                                ...(e.target.files ?? []),
                                ...data.images,
                            ])
                        }
                    />

                    <div className="flex flex-wrap gap-4">
                        {data.images?.map((img) => (
                            <div
                                key={URL.createObjectURL(img)}
                                className="relative"
                            >
                                <button
                                    type="button"
                                    className="absolute end-2 top-2 size-4"
                                    onClick={() =>
                                        setData(
                                            'images',
                                            data.images?.filter(
                                                (i) => i !== img,
                                            ),
                                        )
                                    }
                                >
                                    <XMarkIcon />
                                </button>
                                <img
                                    className="size-44 object-cover rounded-md"
                                    src={URL.createObjectURL(img)}
                                    alt={'Selected image'}
                                />
                            </div>
                        ))}
                    </div>

                    {errors.images && (
                        <InputError message={errors.images} className="mt-2" />
                    )}
                </Card>
            </div>
        </form>
    )
}
