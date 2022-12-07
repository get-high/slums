import React from 'react'
import Axios from 'axios'
import {createSpot} from "../../actions/spotActions";
import {useDispatch, useSelector} from "react-redux";

const CreateForm = () => {

    const { loading, error } = useSelector((state) => state.spot)
    const dispatch = useDispatch()

    const submitForm = (data) => {
        dispatch(createSpot(data))
    }

    return (
        <div>
            <form>
                <input type="text" />
                <input type="text" />
                <input type="text" />
                <input type="text" />
                <input type="text" />
                <button>Добавить</button>
            </form>
        </div>
    );
}

export default CreateForm