import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { FormActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import CreateCatForm from '@/Pages/Tenant/Animals/Cats/Partials/CreateCatForm'

export default function Create({}: AppPageProps<{}>) {
    const __ = useTranslate()

    const FORM_ID = 'create-cat'

    return (
        <AuthenticatedLayout
            title={__('animals.cats.headers.create')}
            actionButtons={FormActionButtons(
                route('animals.cats.index'),
                FORM_ID,
            )}
            formContext={CatFormWrapper.Context}
        >
            <Head title={__('animals.cats.titles.create')} />

            <FormContextProvider context={CatFormWrapper}>
                <CreateCatForm formId={FORM_ID} />
            </FormContextProvider>
        </AuthenticatedLayout>
    )
}
