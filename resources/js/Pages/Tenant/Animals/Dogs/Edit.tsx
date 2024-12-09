import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import EditDogForm from '@/Pages/Tenant/Animals/Dogs/Partials/EditDogForm'
import { DogFormWrapper } from '@/Pages/Tenant/Animals/Dogs/Lib/Dog.context'
import Dog = App.Models.Dog

export default function Edit({
    animal,
}: AppPageProps<{ step: number; animal: Dog }>) {
    const __ = useTranslate()
    const FORM_ID = 'edit-cat'

    return (
        <FormContextProvider context={DogFormWrapper}>
            <AuthenticatedLayout
                title={animal.name}
                actionButtons={FormActionButtons(
                    route('animals.dogs.show', animal.id),
                    FORM_ID,
                )}
                formContext={DogFormWrapper.Context}
            >
                <Head title={__('animals.dogs.titles.edit')} />

                <EditDogForm formId={FORM_ID} animal={animal} />
            </AuthenticatedLayout>
        </FormContextProvider>
    )
}
