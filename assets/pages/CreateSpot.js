import React, {useEffect} from 'react'
import {useForm, Controller} from 'react-hook-form'
import {useDispatch, useSelector} from 'react-redux'
import {fetchCategories} from '../actions/categoryActions'
import {createSpot} from '../actions/spotActions'
import { CKEditor } from 'ckeditor4-react'
import {getSpotSuccessStatus, getSpotLoadingStatus, getSpotErrors, getSpot, clearState} from '../slices/spotSlice'
import {getCategoryStatus, getCategories} from '../slices/categorySlice'
import Select from 'react-select'
import {useNavigate} from 'react-router-dom'

const CreateSpot = () => {
    const categoriesLoading = useSelector(getCategoryStatus);
    const categories = useSelector(getCategories);
    const spotLoadingStatus = useSelector(getSpotLoadingStatus);
    const spotSuccessStatus = useSelector(getSpotSuccessStatus);
    const spotErrors = useSelector(getSpotErrors);
    const spot = useSelector(getSpot);
    const dispatch = useDispatch()
    const navigate = useNavigate()

    const onSubmit = (data) => {
        dispatch(createSpot(data))
    }

    const {
        register,
        formState: {
            errors,
            isValid,
        },
        handleSubmit,
        control,
        setError,
        setValue,
    } = useForm({
        mode: 'onBlur',
    });

    useEffect(() => {
        if (!categoriesLoading && categories.length === 0) {
            dispatch(fetchCategories())
        }
    }, [categoriesLoading, categories, dispatch])

    useEffect(() => {
        if (spotErrors) {
            spotErrors.forEach(function(e){
                setError(e.propertyPath, { type: e.code, message: e.message })
            })
        }
    }, [spotErrors, dispatch]);

    useEffect(() => {
        if (spotSuccessStatus) {
            dispatch(clearState())
            navigate('/admin/spots/' + spot.id )
        }
    }, [spotSuccessStatus, navigate, dispatch]);

    return (
        <div>
            <h1>Create Spot</h1>
            <form onSubmit={handleSubmit(onSubmit)}>
                <label>
                    Title:
                    <input type='text'
                           {...register('title', {
                               required: 'Введите заголовок',
                           })}
                    />
                </label>
                <div>
                    {errors?.title && <p>{errors?.title?.message}</p>}
                </div>

                <label>
                    Slug:
                    <input type='text'
                           {...register('slug', {
                               required: 'Введите slug',
                           })}
                    />
                </label>
                <div>
                    {errors?.slug && <p>{errors?.slug?.message}</p>}
                </div>

                <label>
                    Category:
                    {!categoriesLoading ? (
                        <Controller
                            name='categories'
                            control={control}
                            rules={{ required: true }}
                            render={({ field }) => (
                                <Select {...field} isMulti options={categories.map(({ id, title }) => ({ value: id, label: title}))} />
                            )}
                        />
                    ) : (
                        <div>Загрузка...</div>
                    )}
                </label>

                <div>
                    {errors?.categories && <p>{errors?.categories?.message}</p>}
                </div>

                <label>
                    Address:
                    <input type='text'
                           {...register('address', {
                               required: 'Введите адрес',
                           })}
                    />
                </label>
                <div>
                    {errors?.address && <p>{errors?.address?.message}</p>}
                </div>

                <label>
                    Description:
                    <input type='text'
                           {...register('description', {
                               required: 'Введите description',
                           })}
                    />
                </label>
                <div>
                    {errors?.description && <p>{errors?.description?.message}</p>}
                </div>


                <label>
                    Content:
                    <Controller
                        name='content'
                        control={control}
                        rules={{ required: true }}
                        render={() => (
                            <CKEditor
                                onChange={(value) => setValue('content', value.editor.getData())}
                                config={{
                                    allowedContent: true,
                                    disallowedContent: 'p',
                                    enterMode: 3,
                                    toolbarGroups: [
                                        {name: 'clipboard', groups: ['undo', 'clipboard']},
                                        {name: 'editing', groups: ['find', 'selection', 'editing']},
                                        {name: 'links', groups: ['links']},
                                        {name: 'insert', groups: ['insert']},
                                        {name: 'others', groups: ['others']},
                                        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                                        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'paragraph']},
                                        {name: 'tools', groups: ['tools']},
                                        {name: 'document', groups: ['mode', 'document', 'doctools']}
                                    ],
                                    removeButtons: 'HorizontalRule,RemoveFormat,Outdent,Indent,Superscript,Subscript,Blockquote',
                                    removeDialogTabs: 'link:advanced',
                                }}
                            />
                        )}
                    />
                </label>
                <div>
                    {errors?.content && <p>{errors?.content?.message}</p>}
                </div>

                <label>
                    Lat:
                    <input type='number'
                           step='0.000001'
                           {...register('lat', {
                               required: 'Введите lat',
                               valueAsNumber: true,
                               validate: (value) => value > 0,
                           })}
                    />
                </label>
                <div>
                    {errors?.lat && <p>{errors?.lat?.message}</p>}
                </div>

                <label>
                    Lng:
                    <input type='number'
                           step='0.000001'
                           {...register('lng', {
                               required: 'Введите lnt',
                               valueAsNumber: true,
                               validate: (value) => value > 0,
                           })}
                    />
                </label>
                <div>
                    {errors?.lng && <p>{errors?.lng?.message}</p>}
                </div>

                <label>
                    Is main?:
                    <input type='checkbox'
                        {...register('main')}
                    />
                </label>
                <div>
                    {errors?.main && <p>{errors?.main?.message}</p>}
                </div>


                <label>
                    Image:
                    <input type='file'
                           {...register('image', {
                               required: true,
                           })}
                    />
                </label>
                <div>
                    {errors?.image && <p>{errors?.image?.message}</p>}
                </div>

                <input type='submit' disabled={!isValid || spotLoadingStatus}/>
            </form>
        </div>
    )
}

export default CreateSpot


