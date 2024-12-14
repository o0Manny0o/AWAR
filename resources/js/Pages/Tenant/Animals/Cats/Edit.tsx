import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import useTranslate from '@/shared/hooks/useTranslate'
import EditCatForm from '@/Pages/Tenant/Animals/Cats/Partials/EditCatForm'
import { FormActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import Cat = App.Models.Cat

export default function Edit({ animal }: AppPageProps<{ animal: Cat }>) {
    const __ = useTranslate()
    const FORM_ID = 'edit-cat'

    return (
        <FormContextProvider context={CatFormWrapper}>
            <AuthenticatedLayout
                title={animal.name!}
                actionButtons={FormActionButtons(
                    route('animals.cats.show', animal.id),
                    FORM_ID,
                )}
                formContext={CatFormWrapper.Context}
            >
                <Head title={__('animals.cats.titles.edit')} />

                <EditCatForm formId={FORM_ID} animal={animal} />
            </AuthenticatedLayout>
        </FormContextProvider>
    )
}
