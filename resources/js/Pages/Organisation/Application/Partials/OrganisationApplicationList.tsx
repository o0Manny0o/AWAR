import Application = App.Models.OrganisationApplication
import ApplicationStatus = App.Models.ApplicationStatus
import { Menu, MenuButton, MenuItem } from '@headlessui/react'
import { EllipsisVerticalIcon } from '@heroicons/react/24/solid'
import useTranslate from '@/shared/hooks/useTranslate'
import { Badge, BadgeColor } from '@/Components/_Base/Badge'
import { usePage } from '@inertiajs/react'
import { MenuItems } from '@/Components/_Base/MenuItems'
import { MenuItemLink } from '@/Components/_Base'
import { Button } from '@/Components/_Base/Button'

const statuses: { [key in ApplicationStatus]: string } = {
    draft: 'text-green-700 bg-green-50 ring-green-600/20',
    submitted: 'text-gray-600 bg-gray-50 ring-gray-500/10',
    pending: 'text-yellow-800 bg-yellow-50 ring-yellow-600/20',
    rejected: 'text-yellow-800 bg-yellow-50 ring-yellow-600/20',
    approved: 'text-yellow-800 bg-yellow-50 ring-yellow-600/20',
    created: 'text-yellow-800 bg-yellow-50 ring-yellow-600/20',
}

export default function OrganisationApplicationList({
    applications,
}: {
    applications: Application[]
}) {
    const __ = useTranslate()
    const { locale } = usePage().props

    const badgeColor = (application: Application): BadgeColor => {
        if (application.deleted_at) {
            return BadgeColor.DANGER
        }
        switch (application.status) {
            case 'draft':
                return BadgeColor.WARN
            case 'submitted':
                return BadgeColor.SECONDARY
            case 'pending':
                return BadgeColor.OTHER
            case 'rejected':
                return BadgeColor.DANGER
            case 'approved':
                return BadgeColor.SUCCESS
            case 'created':
                return BadgeColor.SUCCESS
            default:
                return BadgeColor.SECONDARY
        }
    }

    const canEdit = (applications: Application) => {
        return !['approved', 'rejected', 'created'].includes(
            applications.status,
        )
    }

    const canDelete = (applications: Application) => {
        return (
            !applications.deleted_at &&
            !['approved', 'rejected', 'created'].includes(applications.status)
        )
    }

    const canRestore = (applications: Application) => {
        return (
            applications.deleted_at &&
            !['approved', 'rejected', 'created'].includes(applications.status)
        )
    }

    return (
        <ul role="list" className="divide-y divide-gray-100">
            {applications.map((application) => (
                <li
                    key={application.id}
                    className="flex items-center justify-between gap-x-6 py-5"
                >
                    <div className="min-w-0">
                        <div className="flex items-start gap-x-3">
                            <p className="text-md/6 font-semibold text-gray-900 dark:text-gray-100">
                                {application.name}
                            </p>
                            <Badge color={badgeColor(application)}>
                                {application.deleted_at
                                    ? __('general.deleted')
                                    : __(
                                          ('general.status.' +
                                              application.status) as TranslationKey,
                                      )}
                            </Badge>
                        </div>
                        <div className="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
                            <p className="whitespace-nowrap">
                                {application.type}
                            </p>
                            <svg
                                viewBox="0 0 2 2"
                                className="size-0.5 fill-current"
                            >
                                <circle r={1} cx={1} cy={1} />
                            </svg>
                            {__('general.last_update')}
                            <time
                                dateTime={new Date(
                                    application.updated_at,
                                ).toLocaleString(locale)}
                            >
                                {/* TODO: replace with relative date */}
                                {new Date(
                                    application.updated_at,
                                ).toLocaleString(locale)}
                            </time>
                        </div>
                    </div>
                    <div className="flex flex-none items-center gap-x-4">
                        <Button
                            color={'secondary'}
                            href={route(
                                'organisations.applications.show',
                                application.id,
                            )}
                            className="hidden sm:inline-flex"
                        >
                            {__('general.button.view', {
                                resource:
                                    'organisations.applications.application',
                            })}
                            <span className="sr-only">
                                , {application.name}
                            </span>
                        </Button>
                        <Menu
                            as="div"
                            className={
                                'relative flex-none ' +
                                (canEdit(application) ||
                                canDelete(application) ||
                                canRestore(application)
                                    ? ''
                                    : 'sm:hidden')
                            }
                        >
                            <MenuButton className="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900">
                                <span className="sr-only">
                                    {__('general.button.open', {
                                        resource: 'general.options',
                                    })}
                                </span>
                                <EllipsisVerticalIcon
                                    aria-hidden="true"
                                    className="size-5"
                                />
                            </MenuButton>
                            <MenuItems>
                                <MenuItem>
                                    <MenuItemLink
                                        className="sm:hidden"
                                        href={route(
                                            'organisations.applications.show',
                                            application.id,
                                        )}
                                    >
                                        {__('general.button.view', {
                                            resource: '',
                                        })}
                                        <span className="sr-only">
                                            , {application.name}
                                        </span>
                                    </MenuItemLink>
                                </MenuItem>
                                {canEdit(application) && (
                                    <MenuItem>
                                        <MenuItemLink
                                            href={route(
                                                'organisations.applications.edit',
                                                application.id,
                                            )}
                                        >
                                            {__('general.button.edit', {
                                                resource: '',
                                            })}
                                            <span className="sr-only">
                                                , {application.name}
                                            </span>
                                        </MenuItemLink>
                                    </MenuItem>
                                )}

                                {canDelete(application) && (
                                    <MenuItem>
                                        <MenuItemLink
                                            method={'delete'}
                                            as={'button'}
                                            href={route(
                                                'organisations.applications.destroy',
                                                application.id,
                                            )}
                                        >
                                            {__('general.button.delete', {
                                                resource: '',
                                            })}
                                            <span className="sr-only">
                                                , {application.name}
                                            </span>
                                        </MenuItemLink>
                                    </MenuItem>
                                )}

                                {canRestore(application) && (
                                    <MenuItem>
                                        <MenuItemLink
                                            method={'patch'}
                                            as={'button'}
                                            href={route(
                                                'organisations.applications.restore',
                                                application.id,
                                            )}
                                        >
                                            {__(
                                                'general.button.restore' as TranslationKey,
                                                {
                                                    resource: '',
                                                },
                                            )}
                                            <span className="sr-only">
                                                , {application.name}
                                            </span>
                                        </MenuItemLink>
                                    </MenuItem>
                                )}
                            </MenuItems>
                        </Menu>
                    </div>
                </li>
            ))}
        </ul>
    )
}
