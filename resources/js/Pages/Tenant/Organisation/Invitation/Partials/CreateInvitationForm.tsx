import { FormEventHandler, useContext } from 'react'
import { FormInputRefs } from '@/Pages/Organisation/Application/Lib/OrganisationApplication.context'
import { useForm } from '@inertiajs/react'
import { CreateGroup } from '@/Pages/Tenant/Organisation/Invitation/Lib/OrganisationInvitation.components'
import { Button } from '@/Components/_Base/Button'
import useTranslate from '@/shared/hooks/useTranslate'

export default function CreateInvitationForm() {
    const __ = useTranslate()
    const { focusError } = useContext(FormInputRefs.Context)

    // TODO: Disable buttons while processing
    const { data, setData, errors, post, reset, processing, transform } =
        useForm({
            email: '',
            role: 'Member',
        })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('organisation.invitations.store'), {
            preserveScroll: true,
            replace: true,
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }
    return (
        <form onSubmit={submitHandler} className="w-full space-y-6">
            <CreateGroup data={data} errors={errors} setData={setData} />
            <Button className="w-full" disabled={processing}>
                {__('general.button.send', {
                    resource: '',
                })}
            </Button>
        </form>
    )
}
