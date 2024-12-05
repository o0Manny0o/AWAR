import { Card } from '@/Components/Layout/Card'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormEventHandler, useContext } from 'react'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'

interface DogFormProps {
    formId: string
    data: {
        name: string
        date_of_birth: string
        breed: string
    }
    setData: (key: string, value: string) => void
    errors: Partial<{
        name: string
        date_of_birth: string
        breed: string
    }>
    submitHandler: FormEventHandler
}

export function DogForm({
    data,
    setData,
    formId,
    errors,
    submitHandler,
}: DogFormProps) {
    const __ = useTranslate()
    const {
        refs: { name, breed, date_of_birth },
    } = useContext(CatFormWrapper.Context)
    return (
        <form id={formId} onSubmit={submitHandler}>
            <div className="space-y-6 py-6">
                <Card>
                    <InputGroup
                        name="name"
                        placeholder={__('animals.dogs.form.name.placeholder')}
                        value={data.name}
                        ref={name}
                        label={__('animals.dogs.form.name.label')}
                        error={errors.name}
                        onChange={(value) => setData('name', value)}
                    />
                    <InputGroup
                        name="breed"
                        placeholder={__('animals.dogs.form.breed.placeholder')}
                        value={data.breed}
                        ref={breed}
                        label={__('animals.dogs.form.breed.label')}
                        error={errors.breed}
                        onChange={(value) => setData('breed', value)}
                    />
                    <InputGroup
                        name="date_of_birth"
                        placeholder={__(
                            'animals.dogs.form.date_of_birth.placeholder',
                        )}
                        value={data.date_of_birth}
                        ref={date_of_birth}
                        label={__('animals.dogs.form.date_of_birth.label')}
                        error={errors.date_of_birth}
                        type={'date'}
                        onChange={(value) => setData('date_of_birth', value)}
                    />
                </Card>
            </div>
        </form>
    )
}
