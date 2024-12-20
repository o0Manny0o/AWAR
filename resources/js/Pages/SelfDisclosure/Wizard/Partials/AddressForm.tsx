import useTranslate from '@/shared/hooks/useTranslate'
import { useForm, usePage } from '@inertiajs/react'
import { FormEventHandler, useContext, useMemo } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { getCountry } from '@/shared/utils/getUserCountry'
import { InputGroup } from '@/Components/_Base/Input'
import AutocompleteGroup from '@/Components/_Base/Input/AutocompleteGroup'
import { SubmitButton } from '@/Pages/SelfDisclosure/Wizard/Components/SubmitButton'
import Country = App.Models.Country

interface PersonalFormProps {
    data?: any
}

export function AddressForm(props: PersonalFormProps) {
    const __ = useTranslate()

    const {
        focusError,
        refs: { street_address, postal_code, locality, region },
    } = useContext(WizardFormWrapper.Context)

    const {
        data: { countries },
    } = usePage<AppPageProps<{ data: { countries: Country[] } }>>().props

    const country = useMemo(() => getCountry(countries), [countries])

    const { data, setData, errors, patch, reset, processing } = useForm<{
        street_address: string
        locality: string
        region: string
        postal_code: string
        country: string
    }>({
        street_address: props.data?.address?.street_address ?? '',
        postal_code: props.data?.address?.postal_code ?? '',
        locality: props.data?.address?.locality ?? '',
        region: props.data?.address?.region ?? '',
        country: props.data?.address?.country.alpha ?? country?.id ?? '',
    })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('self-disclosure.address.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <form className="w-full space-y-6" onSubmit={submitHandler}>
            <InputGroup
                name={'street_address'}
                placeholder={__('addresses.form.street_address.placeholder')}
                label={__('addresses.form.street_address.label')}
                autoComplete={'street-address'}
                ref={street_address}
                value={data.street_address}
                error={errors.street_address}
                onChange={(v) => setData('street_address', v)}
            />
            <InputGroup
                name={'postal_code'}
                placeholder={__('addresses.form.postal_code.placeholder')}
                label={__('addresses.form.postal_code.label')}
                autoComplete={'postal-code'}
                ref={postal_code}
                value={data.postal_code}
                error={errors.postal_code}
                onChange={(v) => setData('postal_code', v)}
            />
            <InputGroup
                name={'locality'}
                placeholder={__('addresses.form.locality.placeholder')}
                label={__('addresses.form.locality.label')}
                autoComplete={'address-level2'}
                ref={locality}
                value={data.locality}
                error={errors.locality}
                onChange={(v) => setData('locality', v)}
            />
            <InputGroup
                name={'region'}
                placeholder={__('addresses.form.region.placeholder')}
                label={__('addresses.form.region.label')}
                autoComplete={'address-level1'}
                ref={region}
                value={data.region}
                error={errors.region}
                onChange={(v) => setData('region', v)}
            />

            <AutocompleteGroup
                name={'country'}
                label={__('addresses.form.country.label')}
                optionsClassName="[--anchor-max-height:15rem]"
                value={data.country}
                onChange={(v) => setData('country', v?.id ?? '')}
                options={countries}
            />

            <SubmitButton processing={processing} />
        </form>
    )
}
