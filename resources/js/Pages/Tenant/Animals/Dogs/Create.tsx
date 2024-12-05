import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { EditActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import { ElementRefProvider } from '@/shared/contexts/ElementRef.context'
import CreateDogForm from '@/Pages/Tenant/Animals/Dogs/Partials/CreateDogForm'
import { FormInputRefs } from '@/Pages/Tenant/Animals/Dogs/Lib/Dog.context'

export default function Create({}: AppPageProps<{}>) {
    const __ = useTranslate()

    const FORM_ID = 'create-dog'

    return (
        <AuthenticatedLayout
            title={__('animals.dogs.headers.create')}
            actionButtons={EditActionButtons('animals.dogs.index', FORM_ID)}
        >
            <Head title={__('animals.dogs.titles.create')} />

            <ElementRefProvider context={FormInputRefs}>
                <CreateDogForm formId={FORM_ID} />
            </ElementRefProvider>
        </AuthenticatedLayout>
    )
}
