import useTranslate from '@/shared/hooks/useTranslate'
import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import {
    removeTrailingDash,
    transformSubdomain,
} from '@/Pages/Organisation/Application/Lib/OrganisationApplication.util'
import {
    AddressInfoGroup,
    GeneralInfoGroup,
    SubdomainInfoGroup,
} from '@/Pages/Organisation/Application/Lib/OrganisationApplication.components'
import { Card } from '@/Components/Layout/Card'
import { ApplicationFormWrapper } from '@/Pages/Organisation/Application/Lib/OrganisationApplication.context'
import useFormContext from '@/shared/hooks/useFormContext'
import OrganisationApplicationDraft = App.Models.OrganisationApplicationDraft

export default function EditOrganisationForm({
    domain,
    application,
    formId,
}: {
    application: OrganisationApplicationDraft
    domain: string
    formId: string
}) {
    const __ = useTranslate()

    const { data, setData, errors, patch, reset, processing, transform } =
        useForm({
            name: application?.name ?? '',
            type: application?.type ?? '',
            user_role: application?.user_role ?? '',
            registered: application?.registered ?? false,

            street: application?.street ?? '',
            post_code: application?.post_code ?? '',
            city: application?.city ?? '',
            country: application?.country ?? '',

            subdomain:
                application?.subdomain ??
                transformSubdomain(application.name ?? ''),
        })

    const { focusError } = useFormContext(ApplicationFormWrapper, processing)

    transform((data) => ({
        ...data,
        subdomain: removeTrailingDash(transformSubdomain(data.subdomain)),
    }))

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(
            route('organisations.applications.update', {
                application: application.id,
            }),
            {
                preserveScroll: true,
                replace: true,
                onSuccess: () => reset(),
                onError: (errors) => focusError(errors as any),
            },
        )
    }

    return (
        <form id={formId} onSubmit={submitHandler}>
            <div className="space-y-6 py-6">
                <Card
                    header={__('organisations.applications.form.general_info')}
                >
                    <GeneralInfoGroup
                        data={data}
                        errors={errors}
                        setData={setData}
                    />
                </Card>

                <Card
                    header={__('organisations.applications.form.address_info')}
                >
                    <AddressInfoGroup
                        data={data}
                        errors={errors}
                        setData={setData}
                    />
                </Card>

                <Card
                    header={__(
                        'organisations.applications.form.subdomain_info',
                    )}
                >
                    <SubdomainInfoGroup
                        data={data}
                        errors={errors}
                        setData={setData}
                        domain={domain}
                    />
                </Card>
            </div>
        </form>
    )
}
