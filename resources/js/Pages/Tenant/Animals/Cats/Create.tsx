import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { EditActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import { ElementRefProvider } from '@/shared/contexts/ElementRef.context'
import { FormInputRefs } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import CreateCatForm from '@/Pages/Tenant/Animals/Cats/Partials/CreateCatForm'

export default function Create({}: AppPageProps<{}>) {
    const __ = useTranslate()

    const FORM_ID = 'create-cat'

    return (
        <AuthenticatedLayout
            title={__('animals.cats.headers.create')}
            actionButtons={EditActionButtons('animals.cats.index', FORM_ID)}
        >
            <Head title={__('animals.cats.titles.create')} />

            <ElementRefProvider context={FormInputRefs}>
                <CreateCatForm formId={FORM_ID} />
            </ElementRefProvider>
        </AuthenticatedLayout>
    )
}
