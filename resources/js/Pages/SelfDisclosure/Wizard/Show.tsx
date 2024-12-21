import { WizardLayout } from '@/Pages/SelfDisclosure/Wizard/Layouts/WizardLayout'
import {
    AddressForm,
    AnimalSpecificForm,
    ConfirmationForm,
    EligibilityForm,
    ExperienceList,
    FamilyList,
    GardenForm,
    HomeForm,
    PersonalForm,
} from './Partials'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { Head } from '@inertiajs/react'
import { Button } from '@/Components/_Base/Button'

type StepName =
    | 'personal'
    | 'family'
    | 'experiences'
    | 'address'
    | 'home'
    | 'garden'
    | 'eligibility'
    | 'specific'
    | 'confirmation'

export default function Show({
    step,
    previousStep,
    data,
}: AppPageProps<{ step: StepName; data: any; previousStep?: string }>) {
    const __ = useTranslate()

    const renderStep = () => {
        switch (step) {
            case 'family':
                return <FamilyList data={data} />
            case 'experiences':
                return <ExperienceList data={data} />
            case 'address':
                return <AddressForm data={data} />
            case 'home':
                return <HomeForm data={data} />
            case 'garden':
                return <GardenForm data={data} />
            case 'eligibility':
                return <EligibilityForm data={data} />
            case 'specific':
                return <AnimalSpecificForm data={data} />
            case 'confirmation':
                return <ConfirmationForm data={data} />
            case 'personal':
                return <PersonalForm data={data} />
        }
    }

    return (
        <WizardLayout
            header={__(
                ('self_disclosure.wizard.headers.' + step) as TranslationKey,
            )}
            footer={
                step !== 'personal'
                    ? {
                          href: route('dashboard'),
                          label: __('general.button.go_back_to', {
                              page: 'general.navigation.dashboard',
                          }),
                          text: __('self_disclosure.wizard.close_message'),
                      }
                    : undefined
            }
        >
            <Head
                title={__(
                    ('self_disclosure.wizard.headers.' +
                        step) as TranslationKey,
                )}
            />
            <FormContextProvider context={WizardFormWrapper}>
                <div className="w-full">
                    {renderStep()}
                    {previousStep && step !== 'personal' && (
                        <Button
                            color="secondary"
                            className="w-full max-w-xs mx-auto flex mt-4"
                            href={route(previousStep)}
                        >
                            {__('general.button.go_back')}
                        </Button>
                    )}
                </div>
            </FormContextProvider>
        </WizardLayout>
    )
}
