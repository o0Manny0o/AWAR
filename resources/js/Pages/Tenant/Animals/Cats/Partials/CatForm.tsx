import { Card } from '@/Components/Layout/Card'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import { FormEventHandler, useContext } from 'react'
import useTranslate from '@/shared/hooks/useTranslate'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import { CatFormData } from '@/Pages/Tenant/Animals/Lib/Animals.types'
import { ImagesInput } from '@/Components/_Base/Input/Images/ImagesInput'
import { getArrayErrors } from '@/shared/util'
import SelectGroup from '@/Components/_Base/Input/SelectGroup'
import useAnimalOptions from '@/shared/hooks/useAnimalOptions'
import { usePage } from '@inertiajs/react'
import { FamilyGroup } from '@/Components/_Base/Input/FamilyGroup'
import Media = App.Models.Media
import Family = App.Models.Family
import Animal = App.Models.Animal

interface CatFormProps {
    formId: string
    data: CatFormData
    setData: SetDataAction<CatFormData>
    errors: Errors<CatFormData>
    submitHandler: FormEventHandler
    images?: Media[]
    clearErrors: (...keys: string[]) => void
}

export function CatForm({
    data,
    setData,
    formId,
    errors,
    submitHandler,
    images,
    clearErrors,
}: CatFormProps) {
    const __ = useTranslate()
    const {
        refs: { name, breed, date_of_birth, bio, abstract },
    } = useContext(CatFormWrapper.Context)
    const { families, animals } =
        usePage<AppPageProps<{ families: Family[]; animals: Animal[] }>>().props

    const { males: fathers, females: mothers } = useAnimalOptions(animals, {
        ...data,
        name: data.name || 'This Dog',
    })

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
                    <SelectGroup
                        name={'sex'}
                        options={[
                            { value: 'female', label: 'Female' },
                            { value: 'male', label: 'Male' },
                        ]}
                        value={data.sex}
                        onChange={(e) =>
                            setData('sex', e.target.value as 'female' | 'male')
                        }
                        error={errors.sex}
                        label={'sex'}
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

                <Card header={__('general.images')}>
                    <ImagesInput
                        images={images ?? []}
                        onChange={(e) => {
                            setData('images', e)
                            clearErrors?.(
                                ...Object.keys(
                                    getArrayErrors(errors, 'images'),
                                ),
                            )
                        }}
                        errors={getArrayErrors(errors, 'images')}
                    />
                </Card>

                <Card header={__('animals.cats.form.family.header')}>
                    <FamilyGroup
                        families={families}
                        mothers={mothers}
                        fathers={fathers}
                        data={data}
                        setData={setData}
                        errors={errors}
                    />
                </Card>
            </div>
        </form>
    )
}
