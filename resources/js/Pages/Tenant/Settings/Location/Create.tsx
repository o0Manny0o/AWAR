import { Head } from '@inertiajs/react'
import FlowLayout from '@/Layouts/FlowLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import CreateLocationForm from '@/Pages/Tenant/Settings/Location/Partials/CreateLocationForm'
import { LocationFormWrapper } from '@/Pages/Tenant/Settings/Location/Lib/Location.context'

export default function Create() {
    const __ = useTranslate()

    return (
        <FlowLayout
            header={__('organisations.locations.headers.create')}
            footer={{
                text: __('organisations.locations.form.cancel_create'),
                label: __('general.button.go_back'),
                href: route('settings.locations.index'),
            }}
        >
            <Head title={__('organisations.locations.titles.create')} />

            <FormContextProvider context={LocationFormWrapper}>
                <CreateLocationForm />
            </FormContextProvider>
        </FlowLayout>
    )
}
