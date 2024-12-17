import useTranslate from '@/shared/hooks/useTranslate'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { Button } from '@/Components/_Base/Button'

interface PersonalFormProps {
    data?: any
}

export function GardenForm(props: PersonalFormProps) {
    const __ = useTranslate()

    const { data, errors, setData, post, reset, processing } = useForm<{}>({})

    const {
        focusError,
        refs: {},
    } = useContext(WizardFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('self-disclosure.personal.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <form className="w-full space-y-6" onSubmit={submitHandler}>
            <Button className="w-full" disabled={processing}>
                {__('general.button.continue')}
            </Button>
        </form>
    )
}
