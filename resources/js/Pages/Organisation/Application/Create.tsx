import { Head } from '@inertiajs/react'
import CreateOrganisationForm from './Partials/CreateOrganisationForm'
import FlowLayout from '@/Layouts/FlowLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Button } from '@/Components/_Base/Button'
import OrganisationApplicationDraft = App.Models.OrganisationApplicationDraft

export default function Create({
    centralDomain,
    step,
    application,
}: AppPageProps<{
    step: OrganisationApplicationSteps
    application?: OrganisationApplicationDraft
}>) {
    const __ = useTranslate()

    const footer = () => {
        if (step > 1) {
            return {
                text: __('general.continue_later'),
                label: __('general.button.go_back_to', {
                    page: __('general.navigation.overview'),
                }),
                href: application?.id
                    ? route('organisations.applications.show', {
                          application: application.id,
                      })
                    : route('organisations.applications.index'),
            }
        } else {
            return {
                text: __('organisations.applications.form.cancel_create'),
                label: __('general.button.go_back'),
                href: route('organisations.applications.index'),
            }
        }
    }

    return (
        <FlowLayout header="Create Organisation" footer={footer()}>
            <Head title="Create an Organisation Application" />

            <CreateOrganisationForm
                domain={centralDomain}
                step={step}
                application={application}
            />

            {step > 1 && application?.id && (
                <Button
                    color="secondary"
                    className="w-full"
                    href={route('organisations.applications.create.step', {
                        application: application.id,
                        step: step - 1,
                    })}
                >
                    {__('general.button.go_back')}
                </Button>
            )}
        </FlowLayout>
    )
}
