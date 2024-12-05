import useTranslate from '@/shared/hooks/useTranslate'
import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import { Card } from '@/Components/Layout/Card'
import { CreateDogFormWrapper } from '@/Pages/Tenant/Animals/Dogs/Lib/Dog.context'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import useFormContext from '@/shared/hooks/useFormContext'

export default function CreateDogForm({ formId }: { formId: string }) {
    const __ = useTranslate()
    const { data, setData, errors, post, reset, processing } = useForm({
        name: '',
        date_of_birth: '',
        breed: '',
    })

    const {
        refs: { name, breed, date_of_birth },
        focusError,
    } = useFormContext(CreateDogFormWrapper, processing)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('animals.dogs.store'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

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
