import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import useFormContext from '@/shared/hooks/useFormContext'
import { DogFormWrapper } from '@/Pages/Tenant/Animals/Dogs/Lib/Dog.context'
import { DogForm } from '@/Pages/Tenant/Animals/Dogs/Partials/DogForm'
import { DogFormData } from '@/Pages/Tenant/Animals/Lib/Animals.types'
import Dog = App.Models.Dog

export default function EditDogForm({
    animal,
    formId,
}: {
    animal: Dog
    formId: string
}) {
    const { data, setData, errors, post, reset, processing, clearErrors } =
        useForm<DogFormData>({
            name: animal.name ?? '',
            date_of_birth: animal.date_of_birth ?? '',
            breed: animal.animalable.breed ?? '',
            sex: animal.sex ?? 'female',
            bio: animal.bio ?? '',
            abstract: animal.abstract ?? '',
            images: animal.medially?.map((media) => String(media.id)) ?? [],
            _method: 'PATCH',
            // If no family is selected, use the first family as parent instead
            // TODO: Add better support for setting maternal and paternal families
            family:
                animal.animal_family_id ??
                animal.maternal_families?.[0]?.id ??
                animal.paternal_families?.[0]?.id ??
                undefined,
            father:
                animal.father ??
                animal.maternal_families?.[0]?.father?.id ??
                animal.paternal_families?.[0]?.father?.id ??
                undefined,
            mother:
                animal.mother ??
                animal.maternal_families?.[0]?.mother?.id ??
                animal.paternal_families?.[0]?.mother?.id ??
                undefined,
        })

    const { focusError } = useFormContext(DogFormWrapper, processing)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('animals.dogs.update', animal.id), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <DogForm
            formId={formId}
            data={data}
            images={animal.medially}
            setData={setData}
            errors={errors}
            submitHandler={submitHandler}
            clearErrors={clearErrors as any}
        />
    )
}
