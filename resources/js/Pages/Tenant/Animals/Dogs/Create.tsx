import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { FormActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import CreateDogForm from '@/Pages/Tenant/Animals/Dogs/Partials/CreateDogForm'
import { DogFormWrapper } from '@/Pages/Tenant/Animals/Dogs/Lib/Dog.context'

export default function Create({}: AppPageProps<{}>) {
    const __ = useTranslate()

    const FORM_ID = 'create-dog'

    return (
        <FormContextProvider context={DogFormWrapper}>
            <AuthenticatedLayout
                title={__('animals.dogs.headers.create')}
                actionButtons={FormActionButtons(
                    route('animals.dogs.index'),
                    FORM_ID,
                )}
                formContext={DogFormWrapper.Context}
            >
                <Head title={__('animals.dogs.titles.create')} />

                <CreateDogForm formId={FORM_ID} />
            </AuthenticatedLayout>
        </FormContextProvider>
    )
}
