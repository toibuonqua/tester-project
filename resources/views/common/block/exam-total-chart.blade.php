<div class="my-5">
    <h3 class="text-center">{{ __('title.knowledge') }}</h3>
    <div class="row">
        <div class="col-6 offset-3 mb-5">
            <canvas id="doughnut-chart"></canvas>
        </div>
        <div class="col-10 offset-1">
            <canvas id="area-chart"></canvas>
        </div>

    </div>

</div>


@once
    @push('script')
        <script>
            const categoryResult = {{ Illuminate\Support\Js::from($data) }};

            console.log(categoryResult)

            const CHART_COLORS = [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)',
                '#9c1de7',
                '#17b978',
                '#cb3b3b',
                '#713045',
                '#a56cc1',
                '#6c5fa7',
                '#bf5caa'
            ];

            const CHART_BG = [
                'rgba(255, 99, 132,0.5)',
                'rgba(54, 162, 235,0.5)',
                'rgba(255, 159, 64,0.5)',
                'rgba(255, 205, 86,0.5)',
                'rgba(75, 192, 192,0.5)',
                'rgba(153, 102, 255,0.5)',
                'rgba(201, 203, 207,0.5)',
            ];

            const getColor = function (index){
                return CHART_COLORS[index % CHART_COLORS.length]
            }

            const groupBy = function (list, keyGetter) {
                const map = new Map();
                list.forEach((item) => {
                    const key = keyGetter(item);
                    const collection = map.get(key);
                    if (!collection) {
                        map.set(key, [item]);
                    } else {
                        collection.push(item);
                    }
                });
                return map;
            }

            const getDateFromDatetime = function(datetime) {

                datetime = new Date(datetime);

                let date = datetime.getDate();
                let month = datetime.getMonth();
                let year = datetime.getFullYear();

                return date + "-" + (month + 1) + "-" + year;
            }

            // area chart

            let chartData = {
                label: [],
                correct: [],
                incorrect: []
            };

            let groupedData = groupBy(categoryResult,item => item.created_at);

            let i =1;
            groupedData.forEach((item,key)=>{
                let time = '{{ __("title.th") }}'
                let label = `${time} ${i++}: ${getDateFromDatetime(key)}`
                chartData.label.push(label);

                let correct = item.reduce((previousValue, currentValue) => {
                    return previousValue + currentValue.correct
                },0);

                let incorrect = item.reduce((previousValue, currentValue) => {
                    return previousValue + currentValue.incorrect
                },0);

                let percent = Math.round(correct / (correct + incorrect) * 100)

                chartData.correct.push(percent);

                chartData.incorrect.push(100-percent);
            })

            const dataArea = {
                labels: chartData.label,
                datasets: [
                    {
                        label: '{{ __("title.correct") }}',
                        data: chartData.correct,
                        borderColor: CHART_COLORS[1],
                        backgroundColor: CHART_BG[1],
                        fill: 'origin'
                    },
                    {
                        label:  '{{ __("title.incorrect") }}',
                        data: chartData.incorrect,
                        borderColor: CHART_COLORS[0],
                        backgroundColor: CHART_BG[0],
                        fill: '-1'
                    },
                ]
            };

            const configArea = {
                type: 'line',
                data: dataArea,
                options: {
                    scales: {
                        y: {
                            stacked: true,
                            min:0,
                            ticks: {
                                callback: function(value, index, values) {
                                    return value +  '%';
                                }
                            }
                        }
                    },
                    plugins: {
                        filler: {
                            propagate: false
                        },
                        title: {
                            display: true,
                            text: '{{ __("title.correct-incorrect-ratio-over-time") }}'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.dataset.label || '';

                                    if (label) {
                                        label += ` ${context.parsed.y}%`;
                                    }

                                    return label;
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                    },
                },
            };

            const chartTotal = new Chart(
                document.getElementById('area-chart'),
                configArea
            );

            // end area chart

            // doughnut chart

            const doughnutData = {
                labels: [],
                datasets: [
                    {
                        data: [],
                        backgroundColor: [],
                    }
                ]
            };

            const groupByCategory = groupBy(categoryResult,item => item.category_name);

            i=0;
            groupByCategory.forEach((item,key)=>{
                doughnutData.labels.push(key);

                let correct = item.reduce((previousValue, currentValue) => {
                    return previousValue + currentValue.correct
                },0);

                let incorrect = item.reduce((previousValue, currentValue) => {
                    return previousValue + currentValue.incorrect
                },0);

                doughnutData.datasets[0].data.push(correct + incorrect);
                doughnutData.datasets[0].backgroundColor.push(getColor(i++));

            })

            const configDoughnut = {
                type: 'doughnut',
                data: doughnutData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: '{{ __("title.category-ratio")  }}'
                        },

                    }
                },
            };

            const chartDoughnut = new Chart(
                document.getElementById('doughnut-chart'),
                configDoughnut
            );

            // end doughnut chart



        </script>
    @endpush
@endonce
