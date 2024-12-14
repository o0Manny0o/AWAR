import { FormEventHandler, useContext, useMemo } from 'react'
import { useForm, usePage } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { LocationFormData } from '@/Pages/Tenant/Settings/Location/Lib/Location.types'
import { LocationFormWrapper } from '@/Pages/Tenant/Settings/Location/Lib/Location.context'
import { InputGroup, SwitchInput } from '@/Components/_Base/Input'
import AutocompleteGroup from '@/Components/_Base/Input/AutocompleteGroup'
import { getCountry } from '@/shared/utils/getUserCountry'
import Country = App.Models.Country
import Location = App.Models.Location

export default function UpdateLocationForm({
    location,
    formId,
}: {
    location: Location
    formId: string
}) {
    const __ = useTranslate()
    const { countries } =
        usePage<AppPageProps<{ countries: Country[] }>>().props

    const {
        focusError,
        refs: {
            name,
            publicInput,
            street_address,
            postal_code,
            locality,
            region,
        },
    } = useContext(LocationFormWrapper.Context)

    const country = useMemo(() => getCountry(countries), [countries])

    const { data, setData, errors, patch, reset, processing } =
        useForm<LocationFormData>({
            name: location.name ?? '',
            public: location.public ?? false,
            street_address: location.address.street_address ?? '',
            postal_code: location.address.postal_code ?? '',
            locality: location.address.locality ?? '',
            region: location.address.region ?? '',
            country: location.address.country.id ?? country?.id ?? '',
        })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('settings.locations.update', location.id), {
            preserveScroll: true,
            replace: true,
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }
    return (
        <form onSubmit={submitHandler} id={formId} className="w-full space-y-6">
            <InputGroup
                name={'name'}
                placeholder={'name'}
                label={'name'}
                ref={name}
                value={data.name}
                error={errors.name}
                onChange={(v) => setData('name', v)}
            />
            <InputGroup
                name={'street_address'}
                placeholder={'street_address'}
                label={'street_address'}
                autoComplete={'street-address'}
                ref={street_address}
                value={data.street_address}
                error={errors.street_address}
                onChange={(v) => setData('street_address', v)}
            />
            <InputGroup
                name={'postal_code'}
                placeholder={'postal_code'}
                label={'postal_code'}
                autoComplete={'postal-code'}
                ref={postal_code}
                value={data.postal_code}
                error={errors.postal_code}
                onChange={(v) => setData('postal_code', v)}
            />
            <InputGroup
                name={'locality'}
                placeholder={'locality'}
                label={'locality'}
                autoComplete={'address-level2'}
                ref={locality}
                value={data.locality}
                error={errors.locality}
                onChange={(v) => setData('locality', v)}
            />
            <InputGroup
                name={'region'}
                placeholder={'region'}
                label={'region'}
                autoComplete={'address-level1'}
                ref={region}
                value={data.region}
                error={errors.region}
                onChange={(v) => setData('region', v)}
            />

            <AutocompleteGroup
                name={'country'}
                label={'country'}
                optionsClassName="[--anchor-max-height:15rem]"
                value={data.country}
                onChange={(v) => setData('country', v?.id ?? '')}
                options={countries}
            />

            <SwitchInput
                name={'public'}
                checked={data.public}
                ref={publicInput}
                label={'Should the address be public?'}
                description={'The full address will be visible to all users'}
                error={errors.public}
                onChange={(value) => setData('public', value)}
            />
        </form>
    )
}
