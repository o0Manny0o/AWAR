import useTranslate from '@/shared/hooks/useTranslate'
import { FormEventHandler, useContext } from 'react'
import { useForm } from '@inertiajs/react'
import { Card } from '@/Components/Layout/Card'
import { CreateCatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import useFormContext from '@/shared/hooks/useFormContext'

export default function CreateCatForm({ formId }: { formId: string }) {
    const __ = useTranslate()

    const { data, setData, errors, post, reset, processing } = useForm({
        name: '',
        date_of_birth: '',
        breed: '',
    })

    const {
        refs: { name, breed, date_of_birth },
        focusError,
    } = useFormContext(CreateCatFormWrapper, processing)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('animals.cats.store'), {
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
            </div>
        </form>
    )
}
