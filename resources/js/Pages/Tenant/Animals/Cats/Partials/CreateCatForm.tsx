import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import useFormContext from '@/shared/hooks/useFormContext'
import { CatForm } from '@/Pages/Tenant/Animals/Cats/Partials/CatForm'

export default function CreateCatForm({ formId }: { formId: string }) {
    const { data, setData, errors, post, reset, processing } = useForm({
        name: '',
        date_of_birth: '',
        breed: '',
        bio: '',
        abstract: '',
        images: [],
    })

    const { focusError } = useFormContext(CatFormWrapper, processing)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('animals.cats.store'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <CatForm
            formId={formId}
            data={data}
            setData={setData}
            errors={errors}
            submitHandler={submitHandler}
        />
    )
}
