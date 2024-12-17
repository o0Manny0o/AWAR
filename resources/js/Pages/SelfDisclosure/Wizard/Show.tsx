import { WizardLayout } from '@/Pages/SelfDisclosure/Wizard/Layouts/WizardLayout'

export default function Show({
    step,
    data,
}: AppPageProps<{ step: string; data: any }>) {
    console.log(data)

    return <WizardLayout header={step}></WizardLayout>
}
