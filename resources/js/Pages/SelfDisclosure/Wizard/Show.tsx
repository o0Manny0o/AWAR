import { WizardLayout } from '@/Pages/SelfDisclosure/Wizard/Layouts/WizardLayout'
import {
    AddressForm,
    AnimalSpecificForm,
    CompleteForm,
    EligibilityForm,
    ExperienceForm,
    FamilyForm,
    GardenForm,
    HomeForm,
    PersonalForm,
} from './Partials'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'

type StepName =
    | 'personal'
    | 'family'
    | 'experiences'
    | 'address'
    | 'home'
    | 'garden'
    | 'eligibility'
    | 'specific'
    | 'complete'

export default function Show({
    step,
    data,
}: AppPageProps<{ step: StepName; data: any }>) {
    const __ = useTranslate()

    const renderStep = () => {
        switch (step) {
            case 'family':
                return <FamilyForm data={data} />
            case 'experiences':
                return <ExperienceForm data={data} />
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
            case 'complete':
                return <CompleteForm data={data} />
            case 'personal':
                return <PersonalForm data={data} />
        }
    }

    return (
        <WizardLayout
            header={__(
                ('self_disclosure.wizard.headers.' + step) as TranslationKey,
            )}
        >
            <FormContextProvider context={WizardFormWrapper}>
                {renderStep()}
            </FormContextProvider>
        </WizardLayout>
    )
}
