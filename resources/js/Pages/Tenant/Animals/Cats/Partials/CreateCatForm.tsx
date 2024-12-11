import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import useFormContext from '@/shared/hooks/useFormContext'
import { CatForm } from '@/Pages/Tenant/Animals/Cats/Partials/CatForm'
import { CatFormData } from '@/Pages/Tenant/Animals/Lib/Animals.types'

export default function CreateCatForm({ formId }: { formId: string }) {
    const { data, setData, errors, post, reset, processing, clearErrors } =
        useForm<CatFormData>({
            name: '',
            date_of_birth: '',
            breed: '',
            sex: 'female',
            bio: '',
            abstract: '',
            images: [],
            family: undefined,
            father: undefined,
            mother: undefined,
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
            clearErrors={clearErrors as any}
        />
    )
}
