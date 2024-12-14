import { InputGroup, SwitchInput } from '@/Components/_Base/Input'
import AutocompleteGroup from '@/Components/_Base/Input/AutocompleteGroup'
import { useContext } from 'react'
import { LocationFormWrapper } from '@/Pages/Tenant/Settings/Location/Lib/Location.context'
import { LocationFormData } from '@/Pages/Tenant/Settings/Location/Lib/Location.types'
import { usePage } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import Country = App.Models.Country

interface LocationFormProps {
    data: LocationFormData
    errors: Errors<LocationFormData>
    setData: SetDataAction<LocationFormData>
}

export function LocationForm({ data, errors, setData }: LocationFormProps) {
    const __ = useTranslate()
    const {
        refs: {
            name,
            publicInput,
            street_address,
            postal_code,
            locality,
            region,
        },
    } = useContext(LocationFormWrapper.Context)

    const { countries } =
        usePage<AppPageProps<{ countries: Country[] }>>().props

    return (
        <>
            <InputGroup
                name={'name'}
                placeholder={__(
                    'organisations.locations.form.name.placeholder',
                )}
                label={__('organisations.locations.form.name.label')}
                ref={name}
                value={data.name}
                error={errors.name}
                onChange={(v) => setData('name', v)}
            />
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

            <SwitchInput
                name={'public'}
                checked={data.public}
                ref={publicInput}
                label={__('organisations.locations.form.public.label')}
                description={__(
                    'organisations.locations.form.public.description',
                )}
                error={errors.public}
                onChange={(value) => setData('public', value)}
            />
        </>
    )
}
