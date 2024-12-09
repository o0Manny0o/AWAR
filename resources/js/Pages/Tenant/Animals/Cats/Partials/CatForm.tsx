import { Card } from '@/Components/Layout/Card'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import { FormEventHandler, useContext } from 'react'
import useTranslate from '@/shared/hooks/useTranslate'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import { CatFormData } from '@/Pages/Tenant/Animals/Lib/Animals.types'
import { ImageInput } from '@/Components/_Base/Input/Images/ImageInput'
import Media = App.Models.Media

interface CatFormProps {
    formId: string
    data: CatFormData
    setData: (key: string, value: any) => void
    errors: Errors<CatFormData>
    submitHandler: FormEventHandler
    images?: Media[]
}

export function CatForm({
    data,
    setData,
    formId,
    errors,
    submitHandler,
    images,
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
                    <ImageInput
                        images={images ?? []}
                        onChange={(e) => setData('images', e)}
                    />
                </Card>
            </div>
        </form>
    )
}
