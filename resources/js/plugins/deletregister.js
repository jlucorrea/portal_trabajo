import { ElMessageBox, ElMessage } from 'element-plus';
export const deletregister = () => {
    const destroy = (url) => {
        return new Promise((resolve) => {
            ElMessageBox.confirm("Eliminar el registro?", "Eliminar", {
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar",
                type: "warning",
            })
                .then(() => {
                    axios
                        .post(url, { _method: "DELETE" })
                        .then((res) => {
                            if (res.data.success) {
                                ElMessage.success(
                                    "Se eliminó correctamente el registro"
                                );
                                resolve();
                            }
                        })
                        .catch((error) => {
                            if (error.response.status === 500) {
                                ElMessage.error(
                                    "Error al intentar eliminar"
                                );
                            } else {
                                console.log(error.response.data.message);
                            }
                        });
                })
                .catch((error) => {
                    console.log(error);
                });
        });
    };

    return {
        destroy,
    };
};
