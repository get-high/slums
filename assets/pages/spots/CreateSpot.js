import React, {useEffect} from 'react'
import {useForm, Controller} from 'react-hook-form'
import {useDispatch, useSelector} from 'react-redux'
import {fetchCategories} from '../../actions/categoryActions'
import {createSpot} from '../../actions/spotActions'
import {getSpotStatus, getSpotErrors, getSpot} from '../../slices/spotSlice'
import {getCategoryStatus, getCategories} from '../../slices/categorySlice'
import Select from 'react-select'
import {useNavigate} from "react-router-dom";

const CreateSpot = () => {
    const categoriesLoading = useSelector(getCategoryStatus);
    const categories = useSelector(getCategories);
    const spotStatus = useSelector(getSpotStatus);
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
        setError
    } = useForm({
        mode: "onBlur",
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
        if (spot) {
            navigate('/admin/spots/' + spot.id )
        }
    }, [spot, navigate]);

    return (
        <div>
            <h1>Create Spot</h1>
            <form onSubmit={handleSubmit(onSubmit)}>
                <label>
                    Title:
                    <input type="text"
                           {...register("title", {
                               required: "Введите заголовок",
                           })}
                    />
                </label>
                <div>
                    {errors?.title && <p>{errors?.title?.message}</p>}
                </div>

                <label>
                    Slug:
                    <input type="text"
                           {...register("slug", {
                               required: "Введите slug",
                           })}
                    />
                </label>
                <div>
                    {errors?.slug && <p>{errors?.slug?.message}</p>}
                </div>

                {!categoriesLoading ? (
                    <Controller
                        name="categories"
                        control={control}
                        rules={{ required: true }}
                        render={({ field }) => (
                            <Select {...field} isMulti options={categories.map(({ id, title }) => ({ value: id, label: title}))} />
                        )}
                    />
                ) : (
                    <div>Загрузка...</div>
                )}

                <div>
                    {errors?.categories && <p>{errors?.categories?.message}</p>}
                </div>

                <label>
                    Address:
                    <input type="text"
                           {...register("address", {
                               required: "Введите адрес",
                           })}
                    />
                </label>
                <div>
                    {errors?.address && <p>{errors?.address?.message}</p>}
                </div>

                <label>
                    Description:
                    <input type="text"
                           {...register("description", {
                               required: "Введите description",
                           })}
                    />
                </label>
                <div>
                    {errors?.description && <p>{errors?.description?.message}</p>}
                </div>


                <label>
                    Content:
                    <textarea
                           {...register("content", {
                               required: "Введите content",
                           })}
                    />
                </label>
                <div>
                    {errors?.content && <p>{errors?.content?.message}</p>}
                </div>


                <label>
                    Lat:
                    <input type="number"
                           step="0.000001"
                           {...register("lat", {
                               required: "Введите lat",
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
                    <input type="number"
                           step="0.000001"
                           {...register("lng", {
                               required: "Введите lnt",
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
                        {...register("main")}
                    />
                </label>
                <div>
                    {errors?.main && <p>{errors?.main?.message}</p>}
                </div>


                <label>
                    Image:
                    <input type="file"
                           {...register("image", {
                               required: true,
                           })}
                    />
                </label>
                <div>
                    {errors?.image && <p>{errors?.image?.message}</p>}
                </div>

                <input type="submit" disabled={!isValid || spotStatus}/>
            </form>
        </div>
    )
}

export default CreateSpot


